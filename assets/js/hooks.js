import { useTheme } from '@chakra-ui/core';

export const useStatusColors = () => {
  const { colors } = useTheme();

  return {
    draft: colors.gray['400'],
    unpaid: colors.cyan['500'],
    paid: colors.cyan['700'],
    overdue: colors.pink['500'],
    voided: colors.gray['700'],
  };
};

export const useInvoiceStatus = () => [
  'lb-paid',
  'lb-unpaid',
  'lb-overdue',
  'lb-draft',
  'lb-voided',
];

export const useEstimateStatus = () => ['lb-approved', 'lb-declined', 'lb-pending'];
