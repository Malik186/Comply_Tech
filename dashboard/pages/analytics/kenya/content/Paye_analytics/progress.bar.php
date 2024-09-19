<div class="row mt-30">
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progress1" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>NSSF</h5>
							<h3 class="fw-500">Ksh 85,254 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 3%</span></h3>
						</div>
					</div> 
				</div>
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progress2" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>NHIF</h5>
							<h3 class="fw-500">Ksh 48,254 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span></h3>
						</div>
					</div> 
				</div>
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progress3" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>PAYE</h5>
							<h3 class="fw-500">Ksh 11,254 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span></h3>
						</div>
					</div> 
				</div>
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progress4" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>Housing Levy</h5>
							<h3 class="fw-500">Ksh 254 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span></h3>
						</div>
					</div> 
				</div>
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progressbar5" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>Insurance</h5>
							<h3 class="fw-500">Ksh 454 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span></h3>
						</div>
					</div> 
				</div>
				<div class="col-xl-4 col-lg-6 col-12">
					<div class="d-flex align-items-center">
						<div>
							<div id="progress6" class="mx-auto w-100 my-10 position-relative"></div>
						</div>
						<div class="text-start">
							<h5>Mortgage</h5>
							<h3 class="fw-500">Ksh 754 <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span></h3>
						</div>
					</div> 
				</div>
			</div>

            <script>
                // Fetch data from the endpoint
function fetchDataAndUpdateUI() {
    $.ajax({
        url: 'https://complytech.mdskenya.co.ke/endpoint/engine/region/kenya/paye.recent.php', // Replace with your endpoint URL
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Assume data format: { NSSF: 85254, NHIF: 48254, PAYE: 11254, HousingLevy: 254, Insurance: 454, Mortgage: 754 }

            let total = data.nssf + data.nhif + data.paye + data.housing_levy + data.insurance_premium + data.mortgage_interest;

            // Update the h3 elements
            updateValues(data);

            // Calculate progress and update progress bars
            updateProgressBars(data, total);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}

// Update the h3 values dynamically
function updateValues(data) {
    // Update NSSF
    $('h3:contains("NSSF")').html(`Ksh ${data.nssf.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 3%</span>`);
    
    // Update NHIF
    $('h3:contains("NHIF")').html(`Ksh ${data.nhif.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update PAYE
    $('h3:contains("PAYE")').html(`Ksh ${data.paye.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span>`);
    
    // Update Housing Levy
    $('h3:contains("Housing Levy")').html(`Ksh ${data.housing_levy.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update Insurance
    $('h3:contains("Insurance")').html(`Ksh ${data.insurance_premium.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 1%</span>`);
    
    // Update Mortgage
    $('h3:contains("Mortgage")').html(`Ksh ${data.mortgage_interest.toLocaleString()} <span class="fs-16 mx-10 text-fade"><i class="fa fa-arrow-up"></i> 2%</span>`);
}

// Update the progress bars dynamically
function updateProgressBars(data, total) {
    let progress1 = data.nssf / total;
    let progress2 = data.nhif / total;
    let progress3 = data.paye / total;
    let progress4 = data.housing_levy / total;
    let progress5 = data.insurance_premium / total;
    let progress6 = data.mortgage_interest / total;

    animateProgressBar('#progress1', progress1, '#3699ff', 'fa fa-building');
    animateProgressBar('#progress2', progress2, '#EA5455', 'fa fa-hospital');
    animateProgressBar('#progress3', progress3, '#FF9F43', 'fa fa-coins');
    animateProgressBar('#progress4', progress4, '#28C76F', 'fa fa-house');
    animateProgressBar('#progress5', progress5, '#3699ff', 'fa fa-money');
    animateProgressBar('#progress6', progress6, '#7367F0', 'fa fa-house');
}

// Helper function to animate progress bars
function animateProgressBar(selector, value, color, iconClass) {
    var bar = new ProgressBar.Circle(selector, {
        color: color,
        strokeWidth: 30,
        trailWidth: 5,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: { color: color, width: 4 },
        to: { color: color, width: 4 },
        step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);

            var val = Math.round(circle.value() * 100);
            if (val === 0) {
                circle.setText('');
            } else {
                circle.setText(`<i class='${iconClass}'></i>`);
            }
        }
    });

    bar.text.style.fontSize = '1.5rem';
    bar.animate(value); // Set progress bar value
}

// Call fetchDataAndUpdateUI when the document is ready
$(document).ready(function() {
    fetchDataAndUpdateUI();
});

                </script>