import React from 'react';
import { Box } from '@chakra-ui/core';
import moment from 'moment';

const LineItems = ({ allPosts }) => (
  <>
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
  </>
);

export default LineItems;
