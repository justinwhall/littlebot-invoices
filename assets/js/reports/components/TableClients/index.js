import React, { useEffect, useState } from 'react';
import {
  Box, Skeleton, Grid, Button, ButtonGroup,
} from '@chakra-ui/core';
import { makeRequest } from '../../../util';
import { useInvoiceStatus, useEstimateStatus } from '../../../hooks';
import { IS_PAID } from '../constants';

const TableClients = () => {
  const invoiceStatuses = useInvoiceStatus();
  const estimateStatuses = useEstimateStatus();
  const allStatuses = [...invoiceStatuses, ...estimateStatuses];

  const [allClients, setClients] = useState(false);
  const [postType, setPostType] = useState('lb_invoice');
  const [postStatus, setPostStatus] = useState('lb-paid');

  const headers = ['Client Name', 'Email', 'Website', 'Amount'];

  const filterClientTable = (status) => {
    const newPostType = invoiceStatuses.includes(status)
      ? 'lb_invoice'
      : 'lb_estimate';

    setPostType(newPostType);
    setPostStatus(status);
  };

  const getClients = () => {
    const clients = makeRequest(
      `/wp-json/littlebot/v1/clients?status=${postStatus}&post_type=${postType}`,
    );
    clients.then((res) => setClients(res.data));
  };

  useEffect(() => getClients(), [postStatus, postType]);

  if (!allClients) {
    return (
      <div>
        <Skeleton height="20px" my="10px" />
        <Skeleton height="20px" my="10px" />
        <Skeleton height="20px" my="10px" />
      </div>
    );
  }

  return (
    <>
      <ButtonGroup mt={2}>
        {allStatuses.map((status) => (
          <Button
            key={status}
            variantColor="cyan"
            size="sm"
            textTransform="capitalize"
            variant={postStatus === status ? 'solid' : 'outline'}
            onClick={() => filterClientTable(status)}
            isDisabled={!IS_PAID}
          >
            {status.replace('lb-', '')}
          </Button>
        ))}
      </ButtonGroup>
      <Grid gridTemplateColumns="auto auto auto auto" gap={3}>
        {headers.map((header) => (
          <Box key={header} p={3} bg="cyan.700" color="white" mt={3}>
            {header}
          </Box>
        ))}

        {allClients.map((client) => (
          <React.Fragment key={client.ID}>
            <Box p={3} bg="gray.100">
              {client.data.display_name}
            </Box>
            <Box p={3} bg="gray.100">
              {client.data.user_email}
            </Box>
            <Box p={3} bg="gray.100">
              {client.data.user_url}
            </Box>
            <Box p={3} bg="gray.100">
              {client.data.total_paid}
            </Box>
          </React.Fragment>
        ))}
      </Grid>
      {!allClients.length && (
        <Box bg="gray.100" p={4} fontSize={15} textAlign="center" mt={3}>
          No clients yet.
        </Box>
      )}
    </>
  );
};

export default TableClients;
