import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../Interfaces';
import { CreditGroupCard } from './CreditGroupCard';

import { 
	Button,
	Flex,
	Dashicon,
	Card,
	CardBody,
	CardHeader,
	CardFooter,
} from '@wordpress/components';

interface CreditGroupListProps {
	creditGroups: Array<any>;
}

interface CreditGroupListState {
	//
}

export class CreditGroupList extends Component<CreditGroupListProps, CreditGroupListState> {

	constructor( props: CreditGroupListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.creditGroups ).map( ( key: any ) => this.props.creditGroups[ key ] ) as any;
		listItems = listItems.map( ( creditGroup: any, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<CreditGroupCard creditGroup={ creditGroup } />
				</div>
			);
		} );
		return (
			<div style={ { width: '100%' } }>
				{ listItems.length > 0
					//@ts-ignore
					? <Flex direction="column" style={ { width: '100%' } }>{ listItems }</Flex>
					: <div style={ { opacity: 0.5 } }>There are no registered sources</div>
				}
			</div>
		);
	}
}
