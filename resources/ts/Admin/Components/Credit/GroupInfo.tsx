import * as React from 'react';
import { Component } from 'react';
import * as dayjs from 'dayjs'

import { 
	Flex,
} from '@wordpress/components';

interface GroupInfoProps {
	group: any;
}

interface GroupInfoState {
	//
}

export default class GroupInfo extends Component<GroupInfoProps, GroupInfoState> {
	constructor( props: GroupInfoProps ) {
		super( props );
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div><span>UUID: </span><strong>{ this.props?.group?.uuid }</strong></div>
					<div><span>Active: </span><span><strong>{ this.props?.group?.active ? 'Yes' : 'No' }</strong></span></div>
					<div><span>App whitelist: </span><span><strong>{ this.props?.group?.app_whitelist }</strong></span></div>
					<div><span>Created at: </span><span><strong>{ this.dateFormatted( this.props?.group?.created_at ) }</strong></span></div>
					<div><span>Updated at: </span><span><strong>{ this.dateFormatted( this.props?.group?.updated_at ) }</strong></span></div>
				</div>
			</Flex>
		);
	}
}
