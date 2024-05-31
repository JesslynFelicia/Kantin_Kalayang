import moment from 'moment-timezone'
import momen from 'moment'

export const formatToDatetime = (isoTime) => {
  const indonesiaTime = moment(isoTime).tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD HH:mm:ss')
}

export const formatToDate = (isoTime) => {
  const indonesiaTime = moment(isoTime).tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD ')
}

export const today = () => {
  const indonesiaTime = moment().tz('Asia/Jakarta')
  return indonesiaTime.format('YYYY-MM-DD ')
}

export const stringToDate = (stringDate) => {
  const indonesiaTime = momen(stringDate, 'DD-MM-YYYY HH:ii')
  return indonesiaTime.format('YYYY-MM-DD')
}

export const groupBy = (array, f) => {
  let groups = {};
  array.forEach(function (o) {
    var group = JSON.stringify(f(o));
    groups[group] = groups[group] || [];
    groups[group].push(o);
  });
  return Object.keys(groups).map(function (group) {
  return groups[group];
  })
}
