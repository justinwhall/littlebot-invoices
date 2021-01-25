/* eslint-disable camelcase */

import { useMeta } from '../util/useMeta';

const {
  components: {
    SelectControl,
  },
  i18n: {
    __,
  },
  editPost: {
    PluginPostStatusInfo,
  },
  plugins: {
    registerPlugin,
  },
} = wp;

const PostStatusInfo = () => {
  const { meta, updateMeta } = useMeta();

  return (
    <PluginPostStatusInfo>
      <div className="lb-module--status">
        <SelectControl
          label={__('Status', 'littlebot-invoices')}
          value={meta.status}
          onChange={(val) => updateMeta({ status: val })}
          options={[
            { value: 'lb-draft', label: __('Draft', 'littlebot-invoices') },
            { value: 'lb-unpaid', label: __('Unpaid', 'littlebot-invoices') },
            { value: 'lb-paid', label: __('Paid', 'littlebot-invoices') },
            { value: 'lb-overdue', label: __('Overdue', 'littlebot-invoices') },
          ]}
        />
      </div>
    </PluginPostStatusInfo>
  );
};

registerPlugin('littlebot-slot-status-info', { render: PostStatusInfo });
