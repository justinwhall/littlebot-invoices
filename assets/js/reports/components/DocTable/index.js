import React, { useEffect, useState } from 'react';
import { makeRequest } from '../../../util';
import {
  Box,
  Spinner,
  Grid,
  Button,
  SimpleGrid,
  Alert,
  AlertIcon
} from '@chakra-ui/core';
import moment from 'moment';
import { useStatusColors, useStatus } from '../../../hooks';

const DocTable = () => {
  const chartColors = useStatusColors();
  const allStatus = useStatus();

  const [allFetched, setAllFetched] = useState(false);
  const [total, setTotal] = useState(0);
  const [showAlert, setShowAlert] = useState(false);
  const [allPosts, setAllPosts] = useState([]);
  const [statusQuery, setStatusQuery] = useState(['lb-paid']);

  const headers = ['#', 'Date', 'Title', 'Status', 'Amount'];
  let postAggregate = [];
  let page = 1;

  const handleStatusFilter = status => {
    if (statusQuery.includes(status) && statusQuery.length === 1) {
      setShowAlert(true);
      return;
    }

    setShowAlert(false);
    setAllFetched(false);

    let newStatusQuery;
    postAggregate = [];
    page = 1;
    /**
     * Rewmove from array if it's in it.
     */
    if (statusQuery.indexOf(status) !== -1) {
      newStatusQuery = statusQuery.filter(item => item !== status);
    } else {
      newStatusQuery = [...statusQuery, status];
    }

    setStatusQuery(newStatusQuery);
  };

  const getTotal = () => {
    if (!allFetched) {
      return;
    }

    let total = 0;
    allPosts.forEach(post => (total = total + post.lb_meta.total));

    setTotal(total);
  };

  const createCSV = () => {
    let rows = [];

    allPosts.forEach(post => {
      const singleRow = [
        post.id,
        post.date,
        post.title.rendered,
        post.satus,
        post.lb_meta.total
      ];
      rows = [...rows, singleRow];
    });

    const commaList = rows.map(e => e.join(',')).join('\n');
    const csvContent = 'data:text/csv;charset=utf-8,' + commaList;
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');

    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'littlebot-invoices-report.csv');
    document.body.appendChild(link);

    link.click();
  };

  const getPosts = () => {
    const allStatus = statusQuery.join(',');
    const posts = makeRequest(
      `/wp-json/wp/v2/lb_invoice?status=${allStatus}&per_page=100&page=${page}`
    );

    posts.then(res => {
      const totalPages = parseInt(res.headers.get('X-WP-TotalPages'));
      postAggregate = [...postAggregate, ...res.data];

      if (totalPages !== page) {
        page = page + 1;
        return getPosts();
      }

      setAllPosts(postAggregate);
      setAllFetched(true);
    });
  };

  useEffect(() => getPosts(), [statusQuery]);
  useEffect(() => getTotal(), [allFetched]);

  if (!allFetched) {
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
    <>
      {showAlert && (
        <Alert status="info" mt={3}>
          <AlertIcon />
          At least one status filter must be enabled.
        </Alert>
      )}
      <SimpleGrid maxW="500px" gap={4} columns={5} mt={4}>
        {allStatus.map(status => (
          <Button
            onClick={() => handleStatusFilter(status)}
            key={status}
            variantColor={statusQuery.includes(status) ? 'cyan' : 'gray'}
          >
            {status.replace('lb-', '')}
          </Button>
        ))}
      </SimpleGrid>
      <Grid
        gridTemplateColumns="min-content auto minmax(0, 500px) auto auto"
        gap={3}
      >
        {headers.map(header => (
          <Box key={header} p={3} bg="cyan.700" color="white" mt={3}>
            {header}
          </Box>
        ))}

        {allPosts.map(post => (
          <React.Fragment key={post.id}>
            <Box p={3} bg="gray.100">
              {post.id}
            </Box>
            <Box p={3} bg="gray.100">
              {moment(post.date).format('MM/DD/YY')}
            </Box>
            <Box p={3} bg="gray.100">
              {post.title.rendered}
            </Box>
            <Box p={3} bg="gray.100" textTransform="capitalize">
              {post.status.replace('lb-', '')}
            </Box>
            <Box p={3} bg="gray.100">
              {post.lb_meta.total.toFixed(2)}
            </Box>
          </React.Fragment>
        ))}
      </Grid>

      <SimpleGrid columns={2} mt={3}>
        <div>
          <Button variantColor="cyan" onClick={createCSV}>
            Download CSV
          </Button>
        </div>
        <Box textAlign="right" fontSize={20} fontWeight="normal">
          Total: ${total.toFixed(2)}
        </Box>
      </SimpleGrid>
    </>
  );
};

export default DocTable;
