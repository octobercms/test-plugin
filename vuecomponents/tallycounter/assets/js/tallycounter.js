export default {
    props: {
        startAt: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            count: this.startAt
        };
    },
    methods: {
        increment() {
            this.count++;
        },
        reset() {
            this.count = this.startAt;
        }
    }
};
