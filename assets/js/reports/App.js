import React from 'react';
import { ThemeProvider, Box, CSSReset } from '@chakra-ui/core';
import Invoices from './components/Invoices/';
import OverTime from './components/OverTime/';
import Card from './Card';
import DocTable from './components/DocTable';

const App = () => (
  <ThemeProvider>
    <CSSReset />
    <Box mr={5}>
      <Card heading="Invoice Report">
        <DocTable />
      </Card>
      {/* <Card heading="Invoice Summary">
        <Invoices />
      </Card>
      <Card heading="Over Time">
        <OverTime />
      </Card> */}
    </Box>
  </ThemeProvider>
);

export default App;
