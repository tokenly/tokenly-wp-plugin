import * as React from 'react';
import { Component } from 'react';
import { SourceItem } from '../../interfaces';

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
	sourceList: Array<SourceItem>;
}

interface SourceListState {
	//
}

export class SourceList extends Component<SourceListProps, SourceListState> {

	constructor( props: SourceListProps ) {
		super( props );
	}

	render() {
		let listItems = Object.keys( this.props.sourceList ).map( ( key: any ) => this.props.sourceList[key] ) as any;
		listItems = listItems.map( ( sourceItem: SourceItem, i: number ) =>
			<div style={{width: '100%'}}>
				<Card size="extraSmall" style={{width: '100%'}}>
					<CardHeader>
						<div><strong>{sourceItem.address}</strong></div>
					</CardHeader>
					<CardBody style={ { width: '100%' } }>
						<Flex style={ { width: '100%', alignItems: 'center' } }>
							<div style={{flex: 1}}>
								<div><span>Type: </span><span><strong>{sourceItem.type}</strong></span></div>
								<div><span>Assets: </span><strong>{sourceItem.assets ?? 'all'}</strong></div>
							</div>
						</Flex>
					</CardBody>
					<CardFooter>
						<Button
							isSecondary
							isSmall
							href={`/wp-admin/admin.php?page=tokenpass-source-edit&source=${sourceItem.address}`}
						>
							Manage address
						</Button>
					</CardFooter>
				</Card>
			</div>
		);
		return (
			// @ts-ignore
			<Flex style={{width: '100%'}} direction="column">{listItems}</Flex> 
		);
	}
}
