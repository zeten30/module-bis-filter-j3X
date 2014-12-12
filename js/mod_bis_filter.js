window.addEvent('domready', function() {
  new Picker.Date('filter-by-date', {
    timePicker: false,
    format: "%d.%m.%Y",
    positionOffset: {x: 5, y: 0},
    pickerClass: 'datepicker_dashboard',
    useFadeInOut: !Browser.ie
  });
});

window.addEvent('domready', function() {
  new Picker.Date('filter-by-date-to', {
    timePicker: false,
    format: "%d.%m.%Y",
    positionOffset: {x: 5, y: 0},
    pickerClass: 'datepicker_dashboard',
    useFadeInOut: !Browser.ie
  });
});
