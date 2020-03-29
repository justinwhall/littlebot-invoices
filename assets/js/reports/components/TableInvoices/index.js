import React from 'react';
import { useInvoiceStatus } from '../../../hooks';
import DocTable from '../Table';

const InvoiceTable = () => {
  const allStatus = useInvoiceStatus();
  return (
    <DocTable postType="lb_invoice" allStatus={allStatus} initialStatus="lb-paid" />
  );
};

export default InvoiceTable;
