import * as React from 'react';
import { Component } from 'react';
import { GroupCard } from './GroupCard';

import { 
	Flex,
} from '@wordpress/components';

interface GroupListProps {
	groups: any;
	loadingGroups?: boolean;
}

interface GroupListState {
	//
}

export class GroupList extends Component<GroupListProps, GroupListState> {
	constructor( props: GroupListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.groups ).map( ( key: any ) => this.props.groups[ key ] ) as any;
		listItems = listItems.map( ( group: any, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<GroupCard group={ group } />
				</div>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered credit groups</div>
				}
			</div>
		);
	}
}
