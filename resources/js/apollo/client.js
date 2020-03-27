import ApolloClient from 'apollo-boost'

const apolloClient = new ApolloClient({
    uri: '/graphql',
    headers: {
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With' : 'XMLHttpRequest'
    }
});

export default apolloClient;
