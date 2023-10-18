export type User = {
    username: string;
    role: "user" | "admin";
};

export type LoginResponse = {
    message: string;
    access_token: string;
    role: "user" | "admin";
};

export type GetMeResponse = {
    message: string;
    user: User;
};
