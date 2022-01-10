import * as React from 'react';
import { Component } from 'react';
import AccountCard from './AccountCard';

import { 
	Flex,
} from '@wordpress/components';

interface GroupListProps {
	accounts: any;
}

interface GroupListState {
	//
}

export default class GroupList extends Component<GroupListProps, GroupListState> {
	constructor( props: GroupListProps ) {
		super( props );
	}

	render() {
		let listItems = this.props.accounts.map( ( key: any ) => this.props.accounts[ key ] ) as any;
		listItems = listItems.map( ( account: any, i: number ) => {
			return (
				<Flex>
					<AccountCard account={ account } />
				</Flex>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered accounts</div>
				}
			</div>
		);
	}
}
