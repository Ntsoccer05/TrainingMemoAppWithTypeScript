export declare type dispRecordContents ={
    category?: Category,
    emptyData?: number,
    menu?: Menu,
    menuBestVolume?: RecordContents,
    bestWeight?: number,
    menuBestRightWeight?: number,
    menuBestRightVolume?: RecordContents,
    menuBestLeftWeight?: number,
    menuBestLeftVolume?: RecordContents,
}[]

export declare type Records = {
    category?: Category,
    menu?: Menu,
    recorded_at: RecordedAt
}

export declare type Categories = {
    content: string,
    menus?: Menu[],
    created_at: string,
    id: number,
    updated_at: string,
    user_id: number
}[]

export declare type Category = {
    content: string,
    created_at: string,
    id: number,
    updated_at: string,
    user_id: number
};

export declare type Menu = {
    category: Category,
    category_id: number,
    content: string,
    id: number,
    oneSide: number,
    record_contents?: RecordContents[]
};

export declare type HistoryMenu = {
    category_id: number,
    record_state_id: number,
    recorded_at: string,
    created_at: string,
    updated_at: string,
    id: number,
    user_id: number,
};

export declare type HistoryRecord = {
    category_id: number,
    created_at: string,
    id: number,
    left_rep?: number|null,
    left_volume?: number|null,
    left_weight?: number|null,
    memo?: string|null,
    menu_id: number,
    record_menu_id: number,
    record_state_id: number,
    rep?: number|null,
    right_rep?: number|null,
    right_volume?: number|null,
    right_weight?: number|null,
    set: number,
    updated_at: string,
    user_id: number,
    volume?: number|null,
    weight?: number|null,
};


type RecordedAt = {
    record_id: number,
    recorded_at : string
}

type RecordContents ={
    category_id: number,
    created_at: string,
    id: number,
    left_rep?: number|null,
    left_volume?: number|null,
    left_weight?: number|null,
    memo?: string|null,
    menu_id: number,
    record_menu_id: number,
    record_state_id: number,
    rep?: number|null,
    right_rep?: number|null,
    right_volume?: number|null,
    right_weight?: number|null,
    set: number,
    updated_at: string,
    user_id: number,
    volume?: number|null,
    weight?: number|null,
}