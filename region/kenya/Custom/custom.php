<div class="box" id="kenya-custom-form">
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Kenya Custom Tax Calculation</h4>
        </div>
        <div class="card-body">
        <form id="custom-tax-form">
  <!-- Goods Details -->
  <div class="mb-4">
    <h5>Goods Details</h5>
    <div class="mb-3">
      <label for="goodsName" class="form-label">Name of Goods: <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="goodsName" required>
    </div>

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

  <!-- Confirmation -->
  <div class="mb-4">
    <div class="form-check">
      <input type="checkbox" class="form-check-input" id="confirmAccuracy" required>
      <label class="form-check-label" for="confirmAccuracy">
        I confirm that the information provided is accurate and complete.
      </label>
    </div>
  </div>

  <!-- Submit Button -->
  <div class="text-end">
    <button type="submit" id="submit-custom-tax" class="btn btn-primary">Submit Custom Tax Data</button>
  </div>
</form>
        </div>
    </div>
</div>
</div>

    <?php
    include_once site . "/region/kenya/Custom/custom.form.handler.php";
    ?>