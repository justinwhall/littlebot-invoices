import React from 'react';
import { Button, SimpleGrid } from '@chakra-ui/core';


const FilterButtons = ({ statuses, handleFilter, currentStatus }) => (
  <SimpleGrid maxW="500px" gap={4} columns={5} mt={4}>
    {statuses.map(status => (
      <Button
        onClick={() => handleFilter(status)}
        key={status}
        variantColor="cyan"
        variant={currentStatus === status ? 'solid' : 'outline'}
        textTransform="capitalize"
        size="sm"
      >
        {status.replace('lb-', '')}
      </Button>
    ))}
  </SimpleGrid>
);

export default FilterButtons;
