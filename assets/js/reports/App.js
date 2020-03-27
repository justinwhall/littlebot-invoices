import React, { useState } from 'react';
import {
  ThemeProvider,
  Box,
  CSSReset,
  Divider,
  SimpleGrid,
  Button
} from '@chakra-ui/core';
import Invoices from './components/Invoices/';
import OverTime from './components/OverTime/';
import Card from './Card';
import EstimateTable from './components/EstimateTable';
import InvoiceTable from './components/InvoiceTable';

const App = () => {
  const allRoutes = [
    { name: 'Estimate Report', slug: 'EstimateTable' },
    { name: 'Invoice Report', slug: 'InvoiceTable' },
    { name: 'Invoice Summary', slug: 'InvoiceSummary' },
    { name: 'Over Time', slug: 'OverTime' }
  ];
  const [route, setRoute] = useState('InvoiceTable');

  const renderRoute = () => {
    switch (route) {
      case 'InvoiceTable':
        return (
          <Card heading="Estimate Report">
            <InvoiceTable />
          </Card>
        );
      case 'EstimateTable':
        return (
          <Card heading="Estimate Report">
            <EstimateTable />
          </Card>
        );
      case 'InvoiceSummary':
        return (
          <Card heading="Invoices Summary">
            <Invoices />
          </Card>
        );
      case 'OverTime':
        return (
          <Card heading="OverTime">
            <OverTime />
          </Card>
        );
    }
  };

  return (
    <ThemeProvider>
      <CSSReset />
      <SimpleGrid maxW="900px" gap={4} columns={5} mt={4}>
        {allRoutes.map(route => (
          <Button
            onClick={() => setRoute(route.slug)}
            key={route.name}
            // variantColor={statusQuery.includes(status) ? 'cyan' : 'gray'}
            variantColor="pink"
            textTransform="capitalize"
          >
            {route.name}
          </Button>
        ))}
      </SimpleGrid>
      <Divider />
      <Box mr={5}>{renderRoute()}</Box>
    </ThemeProvider>
  );
};

export default App;
