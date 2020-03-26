import React from 'react';
import { Box, Heading } from '@chakra-ui/core';

const Card = ({ heading, children }) => (
  <Box p={4} bg="white" fontSize={15} mt={10}>
    <Heading as="h3" fontSize={20}>
      {heading}
    </Heading>
    {children}
  </Box>
);

export default Card;
