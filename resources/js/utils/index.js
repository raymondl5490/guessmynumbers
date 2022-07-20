const dayjs = require('dayjs');
const customParseFormat = require('dayjs/plugin/customParseFormat')
const utc = require('dayjs/plugin/utc')
const timezone = require('dayjs/plugin/timezone') // dependent on utc plugin
dayjs.extend(customParseFormat)
dayjs.extend(utc)
dayjs.extend(timezone)

/**
 * Return next LiveOn time
 * 
 * ex: console.log(nextLiveOn('2022-03-31 am')) // '2022-03-31 pm'
 * ex: console.log(nextLiveOn('2022-03-31 pm')) // '2022-04-01 am'
 * 
 * @param {string} current ex: 2022-03-22 am
 * @returns string
 */
export const nextLiveOn = function (current) {
    if (!/^\d{4}-\d{2}-\d{2} (am|pm)$/.test(current)) {
        throw `Invalid LiveOn format, got ${current}`;
    }
    if (current.at(11) == 'a') {
        return current.slice(0, 11) + 'pm';
    } else {
        const currentDate = dayjs(current.substring(0, 10), 'YYYY-MM-DD', true);
        return currentDate.add(1, 'day').format('YYYY-MM-DD') + ' am';
    }
};

export const currentLiveOn = function () {
    return dayjs().tz('America/Los_Angeles').format('YYYY-MM-DD a')
};

export const wait = function(miliseconds) {
    return new Promise((res) => {
        setTimeout(() => {
            res('');
        }, miliseconds);
    })
}

/**
 * 
 * @param {string} timestamp
 * 
 * @return {string} formatted date string
 */

export const formatTimestamp2Date = function (timestamp) {
    return dayjs(timestamp).format('ddd MMMM DD YYYY');
}

/**
 * 
 * @param {string} isoDate
 * 
 * @return {string} formatted date string
 */

export const convertISOFormat2Date = function (isoDate) {
    return dayjs(isoDate).format('MM/DD/YY hh:mm a');
}

/**
 * 
 * @returns {string} formatted date of now; ex: Sun July 06 2022
 */
export const formatCurrentTime = function () {
    return dayjs().format('ddd MMMM DD YYYY');
}
