/**
 * BLOCK: Line Item
 *
 */

import edit from './edit';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { withDispatch, withSelect } = wp.data;

registerBlockType('lb/lineitem', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Line Item'), // Block title.
  icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [
    __('my-block — CGB Block'),
    __('CGB Example'),
    __('create-guten-block'),
  ],
  edit,
  attributes: {
    lineItemTitle: {
      default: '',
      type: 'string',
    },
  },
  save: () => null,
});
