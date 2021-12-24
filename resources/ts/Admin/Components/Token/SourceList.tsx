import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../../Interfaces';
import { SourceCard } from './SourceCard';

import { 
	Button,
	Flex,
	Dashicon,
	Card,
	CardBody,
	CardHeader,
	CardFooter,
} from '@wordpress/components';

interface SourceListProps {
	sources: Array<SourceItem>;
	loadingSources: boolean;
}

interface SourceListState {
	//
}

export class SourceList extends Component<SourceListProps, SourceListState> {

	constructor( props: SourceListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.sources ).map( ( key: any ) => this.props.sources[ key ] ) as any;
		listItems = listItems.map( ( sourceItem: SourceItem, i: number ) => {
			return (
				<div style={ { width: '100%' } }>
					<SourceCard source={ sourceItem } />
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
