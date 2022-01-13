import * as React from 'react';
import { Component } from 'react';

import { 
	 Flex,
} from '@wordpress/components';

interface UserInfoProps {
	user: any;
}

export default function UserInfo( props: UserInfoProps ) {
	return (
		<Flex
			//@ts-ignore
			direction="column"
		>
			<div>Name: <b>{ this.props.user?.name } ({ this.props.user?.oauth_user?.username ?? '-' })</b></div>
		</Flex>
	);
}
 

