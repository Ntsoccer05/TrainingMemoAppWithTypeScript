export declare type routes= {
    path: string;
    name: string;
    component: () => Promise<typeof import("/tmp/trainingMemo/src/resources/js/views/home.vue")>;
    meta: {
        requiresAuth: boolean;
    };
    redirect?: string;
}[]