

jQuery('#world-map-markers').vectorMap(
    {
        map: 'world_mill_en',
        backgroundColor: '#fff',
        borderColor: '#818181',
        borderOpacity: 0.25,
        borderWidth: 1,
        color: '#f4f3f0',
        regionStyle : {
            initial : {
              fill : '#1e88e5'
            }
          },
        markerStyle: {
          initial: {
                        r: 9,
                        'fill': '#fff',
                        'fill-opacity':1,
                        'stroke': '#000',
                        'stroke-width' : 5,
                        'stroke-opacity': 0.4
                    },
                    },
        enableZoom: true,
        hoverColor: '#0a89c1',
        markers: [
  {
    latLng: [-1.286389, 36.817223],
    name: 'Kenya'
  },
  {
    latLng: [-6.369028, 34.888822],
    name: 'Tanzania'
  },
  {
    latLng: [1.373333, 32.290275],
    name: 'Uganda'
  },
  {
    latLng: [-30.559482, 22.937506],
    name: 'South Africa'
  },
  {
    latLng: [26.820553, 30.802498],
    name: 'Egypt'
  },
  {
    latLng: [9.081999, 8.675277],
    name: 'Nigeria'
  },
  {
    latLng: [31.791702, -7.092620],
    name: 'Morocco'
  },
  {
    latLng: [37.090240, -95.712891],
    name: 'USA'
  }
],
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: '#c9dfaf',
        selectedRegions: [],
        showTooltip: true,
        onRegionClick: function(element, code, region)
        {
            var message = 'You clicked "'
                + region
                + '" which has the code: '
                + code.toUpperCase();
    
            alert(message);
        }
    });
        