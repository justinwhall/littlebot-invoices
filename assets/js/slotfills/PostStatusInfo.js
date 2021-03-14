import styled from '@emotion/styled';
import { useMeta } from '../util/useMeta';

const {
  components: {
    DateTimePicker,
    SelectControl,
    Popover,
    Button,
  },
  data: {
    useDispatch,
    useSelect,
  },
  date: {
    date,
    __experimentalGetSettings,
  },
  element: {
    useState,
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
  const settings = __experimentalGetSettings();
  const { meta, updateMeta } = useMeta();
  const initialBtnText = meta.dueDate
    ? date(settings.formats.datetime, meta.dueDate)
    : __('Click to set date', 'littlebot-invoices');
  const [buttonText, setButtonText] = useState(initialBtnText);
  const [openDatePopup, setOpenDatePopup] = useState(false);
  const { editPost } = useDispatch('core/editor');
  const status = useSelect(
    (select) => select('core/editor').getEditedPostAttribute('status'),
  );

  return (
    <PluginPostStatusInfo>
      <StyledStatusInfo>
        <div className="lb-due-date components-panel__row">
          <span>{__('Due', 'littlbot-invoices')}</span>
          <Button isTertiary onClick={() => setOpenDatePopup(!openDatePopup)}>
            {buttonText}
            {openDatePopup && (
              <Popover
                onClose={() => setTimeout(() => setOpenDatePopup(false), 150)}
              >
                <div style={{ padding: '12px' }}>
                  <DateTimePicker
                    currentDate={meta.dueDate}
                    onChange={(dueDate) => {
                      updateMeta({ dueDate });
                      setButtonText(date(settings.formats.datetime, dueDate));
                    }}
                    is12Hour
                  />
                </div>
              </Popover>
            )}
          </Button>
        </div>
        <div className="lb-module--status components-panel__row">
          <SelectControl
            label={__('Status', 'littlebot-invoices')}
            labelPosition="side"
            value={status}
            onChange={(val) => {
              editPost({ status: val });
            }}
            options={[
              { value: 'draft', label: __('Draft', 'littlebot-invoices') },
              { value: 'lb-unpaid', label: __('Unpaid', 'littlebot-invoices') },
              { value: 'lb-paid', label: __('Paid', 'littlebot-invoices') },
              // eslint-disable-next-line max-len
              { value: 'lb-overdue', label: __('Overdue', 'littlebot-invoices') },
            ]}
          />
        </div>
      </StyledStatusInfo>
    </PluginPostStatusInfo>
  );
};

const StyledStatusInfo = styled.div`
  width: 100%;

  .lb-module--status > div{
    width: 100%;
  }

  .lb-module--status label{
    margin-right: 40px !important;
    display: inline-block !important;
  }
`;

registerPlugin('littlebot-slot-status-info', { render: PostStatusInfo });
