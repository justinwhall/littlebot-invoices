/**
 * BLOCK: my-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
// import './editor.scss';
// import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { Component } = wp.element;
const { TextControl } = wp.components;
const { compose } = wp.compose;
const { withDispatch, withSelect } = wp.data;

const LineItem = (props) => {
  const hanldeChange = (val) => {
    props.setAttributes({ lineItemTitle: val });
    props.updateMyControlValue(val);
  };
  return (
    <div>
      <label htmlFor="">
        Line item
        <TextControl type="text" value={props.attributes.lineItemTitle} onChange={(val) => hanldeChange(val)} />
      </label>
    </div>
  );
};

const LineItemRedux = compose([
  withDispatch((dispatch, props) => {
    // This function here is the action we created before.
    const { updateMyControlValue } = dispatch('littlebot/lineitems');

    return {
      updateMyControlValue,
    };
  }),
  withSelect((select, props) => {
    // This function here is the selector we created before.
    const { getMyControlValue } = select('littlebot/lineitems');
    // console.log( 'updateMyControlValue', getMyControlValue() );
    return {
      value: getMyControlValue(),
    };
  }),
])(LineItem);

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
  attributes: {
    lineItemTitle: {
      default: '',
      type: 'string',
    },
  },
  edit: LineItemRedux,
  save: () => null,
});
