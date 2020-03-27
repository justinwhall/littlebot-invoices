import React, { useEffect, useState } from 'react';
import { makeRequest } from '../../../util';
import { Box, Spinner, Grid } from '@chakra-ui/core';
import { PieChart, Pie, Tooltip, Cell } from 'recharts';
import { useStatusColors } from '../../../hooks';

const Invoices = () => {
  const chartColors = useStatusColors();
  const [totals, setTotals] = useState(false);

  useEffect(() => {
    const totals = makeRequest('http://littlebot.local/wp-json/littlebot/v1/totals');
    totals.then(res => setTotals(Object.values(res.data)));
  }, []);

  if (!totals) {
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

  const data = totals
    .filter(({ total }) => total)
    .map(({ status, total }) => ({
      name: status.replace('lb-', ''),
      value: total
    }));

  return (
    <Grid templateColumns="300px auto">
      <Box>
        {totals.map(({ count, total, status }, index) => (
          <Grid
            key={status}
            templateColumns="90px auto"
            gap={2}
            p={3}
            textTransform="capitalize"
            bg={index % 2 ? 'transparent' : 'gray.100'}
          >
            <Box>
              {count} {status.replace('lb-', '')}
            </Box>
            <Box>${total}</Box>
          </Grid>
        ))}
      </Box>
      <PieChart width={300} height={220}>
        <Pie
          dataKey="value"
          data={data}
          cx="50%"
          cy="50%"
          outerRadius={100}
          label={false}
        >
          {data.map((entry, index) => (
            <Cell key={`cell-${index}`} fill={chartColors[entry.name]} />
          ))}
        </Pie>
        <Tooltip />
      </PieChart>
    </Grid>
  );
};

export default Invoices;
