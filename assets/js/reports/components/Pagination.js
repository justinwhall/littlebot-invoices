import React from 'react';
import {
    IconButton
} from '@chakra-ui/core';

const Pagination = ({ currentPage, totalPages, setPage }) => (
    <>
        <IconButton
            onClick={() => setPage(currentPage - 1)}
            mr={2}
            aria-label="More"
            icon="chevron-left"
            isDisabled={currentPage === 1}
        />
        <span>{currentPage} of {totalPages}</span>
        <IconButton
            onClick={() => setPage(currentPage + 1)}
            ml={2}
            aria-label="More"
            icon="chevron-right"
            isDisabled={currentPage >= totalPages}
        />
    </>
);

export default Pagination;
