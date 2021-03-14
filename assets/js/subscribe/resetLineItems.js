const getBlockList = () => wp.data.select('core/block-editor').getBlocks();
let blockList = getBlockList();
wp.data.subscribe(() => {
  const newBlockList = getBlockList();
  if (
    newBlockList.length < blockList.length
        && newBlockList.every((block) => block.name !== 'lb/lineitem')
  ) {
    wp.data.dispatch('core/block-editor').resetBlocks(blockList);
  }
  blockList = newBlockList;
});
