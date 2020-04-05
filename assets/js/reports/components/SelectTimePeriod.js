import React from 'react';
import { Select, FormControl, FormLabel } from '@chakra-ui/core';
import DATE_FILTERS from '../DateFilters';

const styles = {
  background: 'none',
  maxWidth: 'inherit',
  minWidth: '250px',
};

const SelectTimePeriod = ({ setTimePeriod, timePeriod }) => (
  <FormControl mt={-2}>
    <FormLabel fontSize={13}>Time Period</FormLabel>
    <Select
      style={styles}
      // placeholder="Select Time Period"
      size="sm"
      defaultValue={timePeriod}
      onChange={(e) => setTimePeriod(e.target.value)}
    >
      {Object.keys(DATE_FILTERS).map((dateKey) => (
        <option
          key={dateKey}
          value={dateKey}
        >
          {DATE_FILTERS[dateKey].label}
        </option>
      ))}
    </Select>
  </FormControl>
);

export default SelectTimePeriod;
