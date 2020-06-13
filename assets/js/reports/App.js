import React, { useState } from 'react';
import {
  ThemeProvider,
  Box,
  CSSReset,
  Tabs,
  TabList,
  Tab,
} from '@chakra-ui/core';
import Invoices from './components/Invoices';
import OverTime from './components/OverTime';
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
    { name: 'Over Time', slug: 'OverTime' },
  ];
  const [currentRoute, setRoute] = useState('InvoiceSummary');

  // eslint-disable-next-line consistent-return
  const renderRoute = () => {
    // eslint-disable-next-line default-case
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
      <Tabs maxW="900px" mt={4}>
        <TabList>
          {allRoutes.map((route) => (
            <Tab
              onClick={() => setRoute(route.slug)}
              key={route.name}
              aria-selected={route.slug === currentRoute ? 'true' : 'false'}
              textTransform="capitalize"
            >
              {route.name}
            </Tab>
          ))}
        </TabList>
      </Tabs>
      <Box mr={5}>{renderRoute()}</Box>
    </ThemeProvider>
  );
};

export default App;
