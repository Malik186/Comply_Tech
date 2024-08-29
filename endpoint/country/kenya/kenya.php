<?php
// File: country.php

// Allow CORS from the front-end domain
header("Access-Control-Allow-Origin: https://complytech.mdskenya.co.ke");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

try {
    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Log received data for debugging
    logError("Received country data: " . print_r($data, true));

    if (isset($data['country']) && $data['country'] === 'Kenya') {
        // Generate the new modal with the dropdown options for Kenya
        $modal = '
        <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">Select Tax Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="taxTypeForm">
                  <div class="form-group">
                    <label for="taxTypeSelect">Tax Type</label>
                    <select class="form-control" id="taxTypeSelect">
                      <option value="PAYE">PAYE</option>
                      <option value="Sales Tax">Sales Tax</option>
                      <option value="VAT">VAT</option>
                      <option value="Payroll">Payroll</option>
                      <option value="Customs">Customs</option>
                      <option value="Excise">Excise</option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitTaxType">Submit</button>
              </div>
            </div>
          </div>
        </div>
        ';

        echo $modal;
    } else {
        // Handle cases for other countries if needed
        echo json_encode(['status' => 'error', 'message' => 'Country not supported.']);
    }
} catch (Exception $e) {
    logError("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
}
?>
