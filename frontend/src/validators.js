import moment from 'moment'


export function isNameJoe(value) {
  if (!value) return true;
  return value === "Joe";
}

export function notGmail(value = "") {
  return !value.includes("gmail");
}

export function isEmailAvailable(value) {
  if (value === "") return true;

  return new Promise((resolve, reject) => {
    setTimeout(() => {
      resolve(value.length > 10);
    }, 500);
  });
}

export function isAntes(value = "", value2 = "") {
  return moment(value).isBefore(value2.dt_vigencia_final)
    //return moment(start).isBefore(end)
}