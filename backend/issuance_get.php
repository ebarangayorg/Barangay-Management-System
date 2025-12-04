<?php
// backend/issuance_get.php
require 'config.php';
header("Content-Type: application/json");

try {
    $issuancesCollection = $client->bms_db->issuances;
    $usersCollection = $client->bms_db->users;

    // Fetch all issuance requests
    $requests = $issuancesCollection->find();
    $requestsArray = iterator_to_array($requests);
    
    // --- Lookup Logic: Fetch resident names from the users collection ---
    
    $finalRequests = [];
    $residentCache = []; 

    foreach ($requestsArray as $req) {
        $req = (array)$req; 
        $email = $req['resident_email'] ?? null;
        
        // --- Determine Name ---
        $residentName = $email; // Default fallback to email
        
        if (isset($residentCache[$email])) {
            $residentName = $residentCache[$email];
        } else {
            // 2. Lookup user registration record using case-insensitive regex for robustness
            $user = $usersCollection->findOne(
                // Use 'i' flag for case-insensitive email match.
                ['email' => ['$regex' => new MongoDB\BSON\Regex('^' . preg_quote($email) . '$', 'i')]], 
                ['projection' => ['fullname' => 1]]
            );
            
            if ($user && isset($user['fullname'])) {
                $resolvedName = $user['fullname'];
            } else {
                $resolvedName = $email; 
            }
            
            $residentName = $resolvedName;
            $residentCache[$email] = $resolvedName; // Store in cache
        }
        
        $req['resident_name'] = $residentName;

        // PDF Fix for OLD Corrupted Records: Override "Resident" name with the resolved name/email
        if (isset($req['resident_name']) && trim($req['resident_name']) === 'Resident') {
            $req['resident_name'] = $residentName;
        }

        $finalRequests[] = $req;
    }

    echo json_encode($finalRequests);

} catch (MongoDB\Driver\Exception\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
}
?>