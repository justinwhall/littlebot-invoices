export const camelToSnake = (str) => str.replace(
  /[A-Z]/g,
  (letter) => `_${letter.toLowerCase()}`,
);

export const snakeToCamel = (str) => str.replace(
  /([-_][a-z])/g,
  (group) => group.toUpperCase()
    .replace('-', '')
    .replace('_', ''),
);

export const convertToCase = (meta, newCase) => {
  const newMeta = {};
  Object.keys(meta).forEach((key) => {
    const objKey = newCase === 'camel' ? snakeToCamel(key) : camelToSnake(key);
    newMeta[objKey] = meta[key];
  });

  return newMeta;
};
