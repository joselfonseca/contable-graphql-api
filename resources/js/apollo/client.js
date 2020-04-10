import ApolloClient from 'apollo-boost'
import ErrorHandler from "./error-handler";

const apolloClient = new ApolloClient({
    uri: '/graphql',
    headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With' : 'XMLHttpRequest'
    },
    onError: ErrorHandler
});

export default apolloClient;
