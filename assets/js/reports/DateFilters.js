import moment from 'moment';

const today = moment().add(1, 'd').format('YYYY-MM-DDT00:00:00');

const DATE_FILTERS = {
  oneWeek: {
    label: '1 Week',
    after: moment().subtract(7, 'd').format('YYYY-MM-DDT00:00:00'),
    before: today,
  },
  oneMonth: {
    label: '1 Month',
    after: moment().subtract(1, 'month').format('YYYY-MM-DDT00:00:00'),
    before: today,
  },
  sixMonths: {
    label: '6 Months',
    after: moment().subtract(6, 'month').format('YYYY-MM-DDT00:00:00'),
    before: today,
  },
  oneYear: {
    label: '1 Year',
    after: moment().subtract(1, 'y').format('YYYY-MM-DDT00:00:00'),
    before: today,
  },
  lastYear: {
    label: 'Last year',
    after: `${moment().subtract(1, 'y').format('YYYY')}-01-01T00:00:00`,
    before: `${moment().format('YYYY')}-01-01T00:00:00`,
  },
};

export default DATE_FILTERS;
