var d = new Date();
var year = d.getFullYear();
var month = d.getMonth() + 1;
if(month < 10){
   month = '0' + month;
}
var day = d.getDate();
if(day < 10){
    day = '0' + day;
}
var hours = d.getHours();
if (hours < 10) {
    hours = '0' + hours;
}
var minutes = d.getMinutes();
if (minutes < 10) {
    minutes = '0' + minutes;
}
// Format: YYYY-MM-DD
var currentDate = year + '-' + month + '-' + day;
// Format: HHMM
var currentTime = hours.toString() + minutes.toString();
console.log(d.getMonth());
console.log('Current date: ' + currentDate);
console.log('Current time: ' + currentTime);