import React, { useEffect, useState } from 'react';
import {
  Box,
  Skeleton,
  Grid,
  Button,
  SimpleGrid,
} from '@chakra-ui/core';
import { makeRequest, createCSV } from '../../../util';
import Pagination from '../Pagination';
import FilterButtons from './filterButtons';
import LineItems from './LineItems';
import SelectTimePeriod from '../SelectTimePeriod';
import DATE_FILTERS from '../../DateFilters';


const DocTable = ({ postType, allStatus, initialStatus }) => {
  const [status, setStatus] = useState(initialStatus);
  const [totalPages, setTotalPages] = useState(0);
  const [allPosts, setAllPosts] = useState(false);
  const [timePeriod, setTimePeriod] = useState('oneWeek');
  const [total, setTotal] = useState(0);
  const [page, setPage] = useState(1);

  const headers = ['count', '#', 'Date', 'Title', 'Status', 'Amount'];

  const getTotal = () => {
    const { after, before } = DATE_FILTERS[timePeriod];
    const req = makeRequest(
      `/wp-json/littlebot/v1/total?status=${status}&post_type=${postType}&after=${after}T00:00:00&before=${before}T00:00:00`,
    );
    req.then((res) => setTotal(res.data));
  };

  const getPosts = () => {
    const { after, before } = DATE_FILTERS[timePeriod];
    setAllPosts(false);
    const posts = makeRequest(
      `/wp-json/wp/v2/${postType}?status=${status}&per_page=100&page=${page}&after=${after}T00:00:00&before=${before}T00:00:00`,
    );

    posts.then((res) => {
      const pages = parseInt(res.headers.get('X-WP-TotalPages'), 10);
      setTotalPages(pages);
      setAllPosts(res.data);
    });
  };

  useEffect(() => getPosts(), [status, page, timePeriod]);
  useEffect(() => getTotal(), [status, timePeriod]);

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
      <Grid
        gridTemplateColumns="auto min-content"
        gap={3}
      >
        <FilterButtons
          statuses={allStatus}
          currentStatus={status}
          handleFilter={setStatus}
        />

        <SelectTimePeriod setTimePeriod={setTimePeriod} timePeriod={timePeriod} />

      </Grid>

      <Grid
        gridTemplateColumns="min-content min-content auto minmax(0, 500px) auto auto"
        gap={3}
      >
        {headers.map((header) => (
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
          <Pagination
            currentPage={page}
            totalPages={totalPages}
            setPage={setPage}
          />
        </Box>

        <Box textAlign="right" fontSize={20} fontWeight="normal">
          Total: $
          {total.toFixed(2)}
        </Box>
      </SimpleGrid>
    </>
  );
};

export default DocTable;
