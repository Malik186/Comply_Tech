<div class="box" id="kenya-excise-form" style="display: none;">
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Kenya Excise Tax Calculation</h4>
      </div>
      <div class="card-body">
        <form id="excise-tax-form">
          <!-- Basic Information -->
          <div class="mb-4">
            <h5>Basic Information</h5>
            <div class="mb-3">
              <label for="importerManufacturer" class="form-label">Importer/Manufacturer Name: <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="importerManufacturer" required>
            </div>
            <div class="mb-3">
              <label for="contactInfo" class="form-label">Contact Information (Phone Number): <span class="text-danger">*</span></label>
              <input type="tel" class="form-control" id="contactInfo" required>
            </div>
          </div>

          <!-- Goods Information -->
          <div class="mb-4">
            <h5>Goods Information</h5>
            <div class="mb-3">
              <label for="productsType" class="form-label">Type of Products: <span class="text-danger">*</span></label>
              <select class="form-select" id="productsType" required onchange="showAdditionalFields()">
                <option value="" disabled selected>Select type of goods</option>
                <option value="Alcoholic Beverages">Alcoholic Beverages</option>
                <option value="Tobacco Products">Tobacco Products</option>
                <option value="Petroleum Products">Petroleum Products</option>
                <option value="Motor Vehicles">Motor Vehicles</option>
              </select>
            </div>

            <!-- Additional Fields for Goods -->
            <div id="additionalFields" class="row"></div>
            <div class="mb-3">
              <label for="goodsType" class="form-label">Type of Goods: <span class="text-danger">*</span></label>
              <select class="form-select" id="goodsType" required>
                <option value="" disabled selected>Select type of goods</option>
                <option value="Capital Goods and Raw Materials">Capital Goods and Raw Materials</option>
                <option value="Intermediate Goods">Intermediate Goods</option>
                <option value="Finished Goods">Finished Goods</option>
                <option value="Sensitive Items">Sensitive Items</option>
              </select>
            </div>
          </div>

          <!-- Description of Goods -->
          <div class="mb-4">
            <label for="goodsDescription" class="form-label">Description of Goods: <span class="text-danger">*</span></label>
            <textarea class="form-control" id="goodsDescription" rows="3" required></textarea>
          </div>

          <!-- CIF Value -->
          <div class="mb-4">
            <h5>CIF Value (Cost, Insurance, Freight)</h5>
            <div class="row">
              <div class="col-md-4">
                <label for="cost" class="form-label">Cost: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="cost" required>
              </div>
              <div class="col-md-4">
                <label for="insurance" class="form-label">Insurance: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="insurance" required>
              </div>
              <div class="col-md-4">
                <label for="freight" class="form-label">Freight: <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="freight" required>
              </div>
            </div>
          </div>

          <!-- Locally Manufactured or Imported -->
          <div class="mb-4">
            <label>Is the product locally manufactured or imported? <span class="text-danger">*</span></label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="goodsOrigin" id="locallyManufactured" value="Locally Manufactured" required>
              <label class="form-check-label" for="locallyManufactured">Locally Manufactured</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="goodsOrigin" id="importedGoods" value="Imported Goods" required>
              <label class="form-check-label" for="importedGoods">Imported Goods</label>
            </div>
          </div>

          <!-- Confirmation -->
          <div class="mb-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
              <label class="form-check-label" for="confirmAccuracy">I confirm that the information provided is accurate and complete.</label>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-end">
            <button type="submit" id="submit-excise-tax" class="btn btn-primary">Submit Excise Tax Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function showAdditionalFields() {
    const productsType = document.getElementById('productsType').value;
    let additionalFields = '';

    if (productsType === 'Alcoholic Beverages') {
      additionalFields = `
        <div class="col-md-6 mb-3">
          <label for="alcoholType" class="form-label">Alcohol Type: <span class="text-danger">*</span></label>
          <select class="form-select" id="alcoholType" required>
            <option value="" disabled selected>Select alcohol type</option>
            <option value="Beer">Beer</option>
            <option value="Cider">Cider</option>
            <option value="Perry">Perry</option>
            <option value="Mead">Mead</option>
            <option value="Opaque Beer">Opaque Beer</option>
            <option value="Fermented Beverages">Fermented Beverages</option>
            <option value="Wines">Wines</option>
            <option value="Spirits">Spirits</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="alcoholQuantity" class="form-label">Quantity (Litres): <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="alcoholQuantity" required>
        </div>
      `;
    } else if (productsType === 'Tobacco Products') {
      additionalFields = `
        <div class="col-md-6 mb-3">
          <label for="tobaccoType" class="form-label">Tobacco Type: <span class="text-danger">*</span></label>
          <select class="form-select" id="tobaccoType" required>
            <option value="" disabled selected>Select tobacco type</option>
            <option value="Cigarettes">Cigarettes</option>
            <option value="Cigars">Cigars</option>
            <option value="Manufactured Tobacco">Manufactured Tobacco</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="tobaccoQuantity" class="form-label">Quantity (Kg): <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="tobaccoQuantity" required>
        </div>
      `;
    } else if (productsType === 'Petroleum Products') {
      additionalFields = `
        <div class="col-md-6 mb-3">
          <label for="petroleumType" class="form-label">Petroleum Type: <span class="text-danger">*</span></label>
          <select class="form-select" id="petroleumType" required>
            <option value="" disabled selected>Select petroleum type</option>
            <option value="Petrol">Petrol</option>
            <option value="Diesel">Diesel</option>
            <option value="Kerosene">Kerosene</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="petroleumQuantity" class="form-label">Quantity (Litres): <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="petroleumQuantity" required>
        </div>
      `;
    } else if (productsType === 'Motor Vehicles') {
      additionalFields = `
        <div class="col-md-6 mb-3">
          <label for="vehicleType" class="form-label">Vehicle Type: <span class="text-danger">*</span></label>
          <select class="form-select" id="vehicleType" required>
            <option value="" disabled selected>Select vehicle type</option>
            <option value="1500-3000cc">1500cc - 3000cc</option>
            <option value="3000cc">Above 3000cc</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="vehicleQuantity" class="form-label">Quantity (Horsepower/cc): <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="vehicleQuantity" required>
        </div>
      `;
    }

    document.getElementById('additionalFields').innerHTML = additionalFields;
  }
</script>
    <?php
    include_once site . "/region/kenya/Excise/form.handler.php";
    ?>