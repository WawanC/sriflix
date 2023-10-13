export type User = {
    username: string;
};

export type LoginResponse = {
    message: string;
    access_token: string;
};

export type GetMeResponse = {
    message: string;
    user: User;
};
