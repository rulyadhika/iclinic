const clockDisplay = document.querySelector(".clockDisplay");
const dateDisplay = document.querySelector(".dateDisplay");
const waktu = document.querySelector(".waktu");

function showTime() {
  let calender = new Date();
  let date = calender.toLocaleDateString("id",{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
  let hour = calender.getHours();
  let minutes = calender.getMinutes();
  let second = calender.getSeconds();

  // if (hour >= 0 && hour < 12) {
  //   waktu.innerHTML = "PAGI";
  // } else if (hour > 12 && hour < 18) {
  //   waktu.innerHTML = "SIANG";
  // } else {
  //   waktu.innerHTML = "MALAM";
  // }

  clockDisplay.innerHTML = `${hour} : ${minutes} : ${second} WIB`;
  dateDisplay.innerHTML = date;
}

setInterval(() => {
  showTime();
}, 1000);
