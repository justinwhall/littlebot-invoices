import React from 'react';
import { useEstimateStatus } from '../../../hooks';
import DocTable from '../Table';

const EstimateTable = () => {
  const allStatus = useEstimateStatus();

  return (
    <DocTable
      postType="lb_estimate"
      allStatus={allStatus}
      initialStatus="lb-approved"
    />
  );
};

export default EstimateTable;