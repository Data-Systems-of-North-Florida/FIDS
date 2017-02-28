function getTimestamp() {
  var curtime = new Date();
  var curhour = curtime.getHours();
  var curmin = curtime.getMinutes();
  var cursec = curtime.getSeconds();
  var time = "";

  if (curhour == 0)
  {
    curhour = 12;
  }
  
  time = (curhour > 12 ? curhour - 12 : curhour) + ":" +
         (curmin < 10 ? "0" : "") + curmin + " " +
         (curhour >= 12 ? "PM" : "AM");

  return time.toString();   
}

function getDatestamp() {
  var currentDate = new Date();
  var month = currentDate.getMonth() + 1;
  var day = currentDate.getDate();
  var year = currentDate.getFullYear();
  var strMonth = "";
  var output = "";
  
  switch(month) {
    case 1:
      strMonth = "January"
      break
    case 2:
      strMonth = "February"
      break
    case 3:
      strMonth = "March"
      break
    case 4:
      strMonth = "April"
      break
    case 5:
      strMonth = "May"
      break
    case 6:
      strMonth = "June"
      break
    case 7:
      strMonth = "July"
      break
    case 8:
      strMonth = "August"
      break
    case 9:
      strMonth = "September"
      break
    case 10:
      strMonth = "October"
      break
    case 11:
      strMonth = "November"
      break
    case 12:
      strMonth = "December"
      break
    default:
      break
  }
  
  output = strMonth + " " + day + ", " + year;
  return output.toString();   
   
   
}