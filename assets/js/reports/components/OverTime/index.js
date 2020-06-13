import React, { useEffect, useState } from 'react';
import { makeRequest } from '../../../util';
import { Spinner } from '@chakra-ui/core';
import { AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip } from 'recharts';
import moment from 'moment';
import { useStatusColors } from '../../../hooks';

const oneYear = moment().subtract(2, 'y').format('YYYY-MM-DDT00:00:00');


const OverTime = () => {
  const [posts, setPosts] = useState(false);
  const colors = useStatusColors();

  useEffect(() => {
    const invoices = makeRequest(
      `http://littlebot.local/wp-json/wp/v2/lb_invoice?status=lb-paid,lb-unpaid,lb-draft,lb-overdue,lb-voided&after=${oneYear}`
    );
    invoices.then(res => setPosts(parseByMonth(res)));
  }, []);

  const parseByMonth = ({ data, headers }) => {
    const months = moment.monthsShort();
    const monthsMap = {};

    console.log(data);

    months.forEach(month => {
      monthsMap[month] = {
        name: month,
        draft: 0,
        unpaid: 0,
        paid: 0,
        overdue: 0,
        voided: 0
      };
    });

    data.forEach(post => {
      const month = moment(post.date).format('MMM');
      const status = post.status.replace('lb-', '');

      monthsMap[month][status] = monthsMap[month][status] + post['lb_meta'].total;
    });

    return Object.values(monthsMap);
  };

  if (!posts) {
    return (
      <Spinner
        thickness="4px"
        speed="0.65s"
        emptyColor="gray.200"
        color="blue.500"
        size="xl"
      />
    );
  }

  return (
    <AreaChart
      width={1000}
      height={400}
      data={posts}
      margin={{ top: 10, right: 30, left: 0, bottom: 0 }}
    >
      <CartesianGrid strokeDasharray="3 3" />
      <XAxis dataKey="name" />
      <YAxis />
      <Tooltip />
      <Area
        type="monotone"
        dataKey="draft"
        stackId="1"
        stroke={colors['draft']}
        fill={colors['draft']}
      />
      <Area
        type="monotone"
        dataKey="unpaid"
        stackId="1"
        stroke={colors['unpaid']}
        fill={colors['unpaid']}
      />
      <Area
        type="monotone"
        dataKey="paid"
        stackId="1"
        stroke={colors['paid']}
        fill={colors['paid']}
      />
      <Area
        type="monotone"
        dataKey="overdue"
        stackId="1"
        stroke={colors['overdue']}
        fill={colors['overdue']}
      />
      <Area
        type="monotone"
        dataKey="voided"
        stackId="1"
        stroke={colors['voided']}
        fill={colors['voided']}
      />
    </AreaChart>
  );
};

export default OverTime;
