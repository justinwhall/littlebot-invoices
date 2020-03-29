import React, { useEffect, useState } from 'react';
import { makeRequest, createCSV } from '../../../util';
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
import FilterButtons from './filterButtons';
import LineItems from './LineItems';

const DocTable = ({ postType, allStatus, initialStatus }) => {
  const [status, setStatus] = useState(initialStatus);
  const [totalPages, setTotalPages] = useState(0);
  const [allPosts, setAllPosts] = useState(false);
  const [total, setTotal] = useState(0);
  const [page, setPage] = useState(1);

  const headers = ['count', '#', 'Date', 'Title', 'Status', 'Amount'];

  const getTotal = () => {
    const total = makeRequest(
      `/wp-json/littlebot/v1/total?status=${status}&post_type=${postType}`
    );
    total.then(res => setTotal(res.data));
  };

  const getPosts = () => {
    setAllPosts(false);
    const posts = makeRequest(
      `/wp-json/wp/v2/${postType}?status=${status}&per_page=100&page=${page}`
    );

    posts.then(res => {
      const totalPages = parseInt(res.headers.get('X-WP-TotalPages'));
      setTotalPages(totalPages);
      setAllPosts(res.data);
    });
  };

  useEffect(() => getPosts(), [status, page]);
  useEffect(() => getTotal(), [status]);

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
      <FilterButtons
        statuses={allStatus}
        currentStatus={status}
        handleFilter={setStatus}
      />

      <Grid
        gridTemplateColumns="min-content min-content auto minmax(0, 500px) auto auto"
        gap={3}
      >
        {headers.map(header => (
          <Box key={header} p={3} bg="cyan.700" color="white" mt={3}>
            {header}
          </Box>
        ))}

        <LineItems allPosts={allPosts} />
      </Grid>

      {!allPosts.length && (
        <Box bg="gray.100" p={4} fontSize={15} textAlign="center" mt={3}>
          No results for that query :(
        </Box>
      )}

      <SimpleGrid columns={3} mt={3}>
        <div>
          <Button variantColor="cyan" onClick={() => createCSV(allPosts)}>
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
