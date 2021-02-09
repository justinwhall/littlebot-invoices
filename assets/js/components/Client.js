import styled from '@emotion/styled';
import colors from '../lib/colors';
import { useMeta } from '../util/useMeta';

const {
  apiFetch,
  components: {
    SelectControl,
    TextControl,
    Spinner,
  },
  url: {
    addQueryArgs,
  },
  element: {
    useState,
    useEffect,
  },
  i18n: {
    __,
  },
} = wp;

const ClientMeta = ({ id }) => {
  const [client, setClient] = useState(null);

  const fetchUser = async (userId) => {
    console.log('id', userId);
    const user = await apiFetch({ path: `/wp/v2/users/${userId}` });
    console.log(user);
    setClient(user);
  };

  useEffect(() => {
    console.log(id);
    fetchUser(id);
  }, [id]);

  if (!client) {
    return null;
  }

  return (
    <StyledClientMeta>
      <div>
        <strong>{__('Name')}</strong>
        {' '}
        {client.name}
      </div>
      <div>
        <strong>{__('Company')}</strong>
        {' '}
        {client.meta.company_name}
      </div>
    </StyledClientMeta>
  );
};

const Client = () => {
  const { meta, updateMeta } = useMeta();
  const [clients, setClients] = useState([]);
  const [fetching, setFetching] = useState(false);
  const [search, setSearch] = useState('');
  const [selectedClient, setSelectedClient] = useState(meta.client);
  const noResults = !clients.length && search.length && !fetching;

  console.log(search.length);

  const fetchClients = async (query) => {
    setFetching(true);
    const path = addQueryArgs(
      '/littlebot/v1/users/',
      {
        s: query,
      },
    );
    const res = await apiFetch({ path });
    setClients(res);
    setFetching(false);
  };

  useEffect(() => {
    updateMeta({ client: selectedClient });
  }, [selectedClient]);

  useEffect(() => {
    if (search.length) {
      fetchClients(search);
    } else {
      setClients([]);
    }
  }, [search]);

  return (
    <>
      <span>{__('Client', 'littlebot-invoices')}</span>
      {selectedClient ? (
        <ClientMeta id={selectedClient} />
      ) : null}
      <TextControl
        onChange={(val) => setSearch(val)}
        placeholder="Search for a client"
      />
      {clients.length ? (
        <SelectControl
          onChange={(val) => setSelectedClient(val)}
          options={[
            {
              label: __('Select Client', 'littlebot-invoices'),
              value: '',
            },
            ...clients.map(({ data, ID }) => {
              let optLabel = data.company.length ? `${data.company} | ` : '';
              optLabel += data.display_name;

              return {
                label: optLabel,
                value: ID,
              };
            }),
          ]}
        />
      ) : null}
      {noResults ? (
        <StyledNoResults>
          {__('No Results', 'littlebot-invoices')}
        </StyledNoResults>
      ) : null}
      {fetching ? <Spinner /> : null}
    </>
  );
};

const StyledClientMeta = styled.div`
  background: ${colors.gray100};
  padding: 10px;
  margin-bottom: 10px;
`;

const StyledNoResults = styled.div`
  color: ${colors.red};
  margin-bottom: 10px;
`;

export default Client;
