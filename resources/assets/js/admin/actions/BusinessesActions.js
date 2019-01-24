import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

// export const setPost = (id, attributes) => {
//     return (dispatch) => {
//         dispatch({ type: 'SET-POST', id, attributes })
//     }
// }

// export const updatePost = (post) => {
//     return (dispatch) => {
//         putting(routes('api.posts.update',[post.id]), post.attributes)
//             .then(response => dispatch({
//                 type: 'UPDATE-POST',
//                 payload: response.data
//             }))
//             .catch( error => { console.log(error.response) } );
//     }
// }

export const getBusinesses = () => {
    return (dispatch) => {
        getting(routes('api.businesses.index'))
            .then((response) => {
                console.log(response);
                
                return dispatch({
                type: 'GET-BUSINESSES',
                payload: response.data
                })
            })
            .catch( error => { console.log(error.response) } );
    }
}