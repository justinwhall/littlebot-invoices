const {
  apiFetch,
  components: {
    SelectControl,
    TextControl,
  },
  url: {
    addQueryArgs,
  },
  // date: {
  //   date,
  // },
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

  console.log('id', id);

  const fetchUser = async (userId) => {
    const user = await apiFetch({ path: `/wp/v2/users/${userId}` });
    console.log(user);
    setClient(user);
  };

  useEffect(() => {
    fetchUser(id);
  }, []);

  return (
    <div>{ }</div>
  );
};

const Client = () => {
  const [clients, setClients] = useState([]);
  const [selectedClient, setSelectedClient] = useState(0);

  const fetchClient = async (query) => {
    const path = addQueryArgs(
      '/littlebot/v1/users/',
      {
        s: query,
      },
    );
    const res = await apiFetch({ path });
    setClients(res);
  };

  console.log(selectedClient);

  if (selectedClient) {
    return <ClientMeta id={selectedClient} />;
  }

  return (
    <>
      <TextControl
        label={__('Select Client', 'littlebot-invoices')}
        onChange={(val) => fetchClient(val)}
        placeholder="Search For client"
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
    </>
  );
};

export default Client;
