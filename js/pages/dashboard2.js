//[Dashboard Javascript]

//Project:	ComplyTech
//Primary use:   Used only for the main dashboard


$(function () {

    'use strict';
      
          var bar = new ProgressBar.Circle(progress1, {
            color: '#3699ff',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#3699ff', width: 4 },
            to: { color: '#3699ff', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-building'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.78);
      
      
          var bar = new ProgressBar.Circle(progress2, {
            color: '#EA5455',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#EA5455', width: 4 },
            to: { color: '#EA5455', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-hospital'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.5);
      
      
          var bar = new ProgressBar.Circle(progress3, {
            color: '#FF9F43',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#FF9F43', width: 4 },
            to: { color: '#FF9F43', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-coins'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.4);
      
      
      
          var bar = new ProgressBar.Circle(progress4, {
            color: '#28C76F',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#28C76F', width: 4 },
            to: { color: '#28C76F', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-house'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.3);
      
      
      
          var bar = new ProgressBar.Circle(progress5, {
            color: '#3699ff',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#3699ff', width: 4 },
            to: { color: '#3699ff', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-money'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.25);
      
      
      
          var bar = new ProgressBar.Circle(progress6, {
            color: '#7367F0',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 30,
            trailWidth: 5,
            easing: 'easeInOut',
            duration: 1400,
            text: {
              autoStyleContainer: false
            },
            from: { color: '#7367F0', width: 4 },
            to: { color: '#7367F0', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
              circle.path.setAttribute('stroke', state.color);
              circle.path.setAttribute('stroke-width', state.width);
  
              var value = Math.round(circle.value() * 150);
              if (value === 0) {
                circle.setText('');
              } else {
                circle.setText("<i class='fa fa-house'></i>");
              }
  
            }
          });
          bar.text.style.fontSize = '1.5rem';
  
          bar.animate(0.15);
      
      
      
      
      
      
  }); // End of use strict