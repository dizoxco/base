export const flushSnacks = () => dispatch => {
    dispatch({ type: 'FLUSH-SNACKS' });
};