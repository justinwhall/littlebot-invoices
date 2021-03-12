export const toCents = (dollars) => dollars * 100;

export const toDollars = (cents, fixed = true) => {
  const dollars = parseInt(cents, 10) / 100;
  return fixed ? dollars.toFixed(2) : dollars;
};
