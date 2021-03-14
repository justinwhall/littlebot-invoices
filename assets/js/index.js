/**
 * Entry point for all Littlebot gutenberg 🤖
 */

// Blocks.
import './blocks/store';
import './blocks/SideBar';
import './blocks/LineItem/index.js';
import './blocks/LineItems/index.js';
import './blocks/Totals/index.js';
// Slotfills.
import './slotfills/PostStatusInfo.js';
import './slotfills/LittleBotSettingsPanel.js';

let initialized = false;
let editorIsDirty;

const Button = () => {
  const isDirty = wp.data.select('core/editor').isEditedPostDirty();
  const { savePost } = wp.data.useDispatch('core/editor');
  console.log('isDirty', isDirty);

  return (
    <button
      aria-disabled={!isDirty}
      type="button"
      onClick={savePost}
      className="is-primary components-button"
    >
      Save
    </button>
  );
};

const renderButton = (el) => {
  const isDirty = wp.data.select('core/editor').isEditedPostDirty();

  // No change in state. Return early.
  if (isDirty === editorIsDirty) {
    return;
  }

  editorIsDirty = isDirty;
  const node = el || document.querySelector('.lb-save-post');

  // eslint-disable-next-line no-undef
  ReactDOM.render(
    <Button />,
    node,
  );
};

const maybeInitSaveButton = async () => {
  if (initialized) {
    renderButton();
    return;
  }

  const saveButton = document.querySelector(
    '.editor-post-publish-panel__toggle',
  );

  if (!saveButton) {
    return;
  }

  const container = document.createElement('span');
  container.classList.add('lb-save-post');
  saveButton.parentElement.insertBefore(container, saveButton);

  renderButton(container);
  editorIsDirty = false;
  initialized = true;
};

wp.data.subscribe(() => maybeInitSaveButton());
