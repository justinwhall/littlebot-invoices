import React, { useState } from 'react';
import {
  ThemeProvider,
  Box,
  CSSReset,
  Divider,
  SimpleGrid,
  Button,
  Tabs,
  TabList,
  TabPanels,
  Tab,
  TabPanel
} from '@chakra-ui/core';
import Invoices from './components/Invoices/';
import OverTime from './components/OverTime/';
import Card from './Card';
import EstimateTable from './components/TableEstimates';
import InvoiceTable from './components/TableInvoices';
import ClientTable from './components/TableClients';

const App = () => {
  const allRoutes = [
    { name: 'Invoice Summary', slug: 'InvoiceSummary' },
    { name: 'Invoice Table', slug: 'InvoiceTable' },
    { name: 'Estimate Table', slug: 'EstimateTable' },
    { name: 'Client Table', slug: 'ClientTable' },
    { name: 'Over Time', slug: 'OverTime' }
  ];
  const [currentRoute, setRoute] = useState('ClientTable');

  const renderRoute = () => {
    switch (currentRoute) {
      case 'ClientTable':
        return (
          <Card heading="Client Table">
            <ClientTable />
          </Card>
        );
      case 'InvoiceTable':
        return (
          <Card heading="Invoice Table">
            <InvoiceTable />
          </Card>
        );
      case 'EstimateTable':
        return (
          <Card heading="Estimate Table">
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
          <Card heading="Over Time">
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
            variantColor={route.slug === currentRoute ? 'pink' : 'gray'}
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
