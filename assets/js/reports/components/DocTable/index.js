import React, { useEffect, useState } from 'react';
import { makeRequest } from '../../../util';
import {
  Box,
  Skeleton,
  Grid,
  Button,
  SimpleGrid,
  Alert,
  AlertIcon,
  IconButton
} from '@chakra-ui/core';
import moment from 'moment';

const DocTable = ({ postType, allStatus, initialStatus }) => {
  const [statusQuery, setStatusQuery] = useState([initialStatus]);
  const [totalPages, setTotalPages] = useState(0);
  const [showAlert, setShowAlert] = useState(false);
  const [allPosts, setAllPosts] = useState(false);
  const [total, setTotal] = useState(0);
  const [page, setPage] = useState(1);

  const headers = ['count', '#', 'Date', 'Title', 'Status', 'Amount'];

  const handleStatusFilter = status => {
    if (statusQuery.includes(status) && statusQuery.length === 1) {
      setShowAlert(true);
      return;
    }

    setShowAlert(false);
    let newStatusQuery;

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
    const allStatus = statusQuery.join(',');
    const total = makeRequest(`/wp-json/littlebot/v1/total?status=${allStatus}`);
    total.then(res => setTotal(res.data));
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
    setAllPosts(false);
    const allStatus = statusQuery.join(',');
    const posts = makeRequest(
      `/wp-json/wp/v2/${postType}?status=${allStatus}&per_page=100&page=${page}`
    );

    posts.then(res => {
      const totalPages = parseInt(res.headers.get('X-WP-TotalPages'));
      setTotalPages(totalPages);
      setAllPosts(res.data);
    });
  };

  useEffect(() => getPosts(), [statusQuery, page]);
  useEffect(() => getTotal(), [statusQuery]);

  if (!allPosts) {
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
            textTransform="capitalize"
          >
            {status.replace('lb-', '')}
          </Button>
        ))}
      </SimpleGrid>

      <Grid
        gridTemplateColumns="min-content min-content auto minmax(0, 500px) auto auto"
        gap={3}
      >
        {headers.map(header => (
          <Box key={header} p={3} bg="cyan.700" color="white" mt={3}>
            {header}
          </Box>
        ))}

        {allPosts.map((post, index) => (
          <React.Fragment key={post.id}>
            <Box p={3} bg="gray.100">
              {index + 1}
            </Box>
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

      {!allPosts.length && (
        <Box bg="gray.100" p={4} fontSize={15} textAlign="center" mt={3}>
          No results for that query :(
        </Box>
      )}

      <SimpleGrid columns={3} mt={3}>
        <div>
          <Button variantColor="cyan" onClick={createCSV}>
            Download CSV
          </Button>
        </div>
        <Box textAlign="center">
          {page !== 1 && (
            <IconButton
              onClick={() => setPage(page - 1)}
              mr={2}
              aria-label="More"
              icon="chevron-left"
            />
          )}
          {page < totalPages && (
            <IconButton
              onClick={() => setPage(page + 1)}
              ml={2}
              aria-label="More"
              icon="chevron-right"
            />
          )}
        </Box>
        <Box textAlign="right" fontSize={20} fontWeight="normal">
          Total: ${total.toFixed(2)}
        </Box>
      </SimpleGrid>
    </>
  );
};

export default DocTable;
// $ wp post generate count=2  | xargs -n1 -I % wp --url=% option update my_option my_value
//  wp post generate --count=2  --format=ids | xargs -n1 -I % wp post meta add % _lb_total 100
