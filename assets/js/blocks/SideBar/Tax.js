const { TextControl } = wp.components;

const Tax = ({ metaValue, setMetaField }) => (
  <TextControl
    label="Tax %"
    value={metaValue}
    onChange={(val) => setMetaField('tax', val)}
  />
);

export default Tax;
