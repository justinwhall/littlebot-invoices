let initialized = false;
let editorIsDirty;

/**
 * The actual JSX for the button.
 */
const SaveButton = () => {
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

/**
 * Logic to render button.
 */
const renderButton = () => {
  const isDirty = wp.data.select('core/editor').isEditedPostDirty();

  // No change in state. Return early.
  if (isDirty === editorIsDirty) {
    return;
  }

  editorIsDirty = isDirty;
  const node = document.querySelector('.lb-save-post');

  // eslint-disable-next-line no-undef
  ReactDOM.render(
    <SaveButton />,
    node,
  );
};

const maybeInitSaveButton = () => {
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

  renderButton();
  editorIsDirty = false;
  initialized = true;
};

wp.data.subscribe(() => {
  const postId = wp.data.select('core/editor').getCurrentPostId();
  const postType = wp.data.select('core/editor').getCurrentPostType();
  console.log(postType);

  if (!postId || !['lb_invoice', 'lb_estimate'].includes(postType)) {
    return;
  }

  maybeInitSaveButton();
});
